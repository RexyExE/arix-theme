import React, { useEffect, useMemo, useState } from 'react';
import { useStoreState } from 'easy-peasy';
import { ApplicationStore } from '@/state';
import { ServerContext } from '@/state/server';
import { SocketEvent, SocketRequest } from '@/components/server/events';
import { Button } from '@/components/elements/button/index';
import useWebsocketEvent from '@/plugins/useWebsocketEvent';
import { ExclamationIcon } from '@heroicons/react/outline';
import { useTranslation } from 'react-i18next';

type Stats = Record<'memory' | 'cpu' | 'disk' | 'uptime', number>;

export default () => {
    const { t } = useTranslation('arix/utilities');
    const [stats, setStats] = useState<Stats>({ memory: 0, cpu: 0, disk: 0, uptime: 0 });
    
    const arix = useStoreState((state: ApplicationStore) => state.settings.data?.arix);
    const lowResourcesAlert = arix?.lowResourcesAlert;
    const alertLink = arix?.alertLink || '';

    const connected = ServerContext.useStoreState((state) => state.socket.connected);
    const instance = ServerContext.useStoreState((state) => state.socket.instance);
    const limits = ServerContext.useStoreState((state) => state.server.data!.limits);

    useEffect(() => {
        if (!connected || !instance) {
            return;
        }

        instance.send(SocketRequest.SEND_STATS);
    }, [instance, connected]);

    useWebsocketEvent(SocketEvent.STATS, (data) => {
        let values: any = {};
        try {
            values = JSON.parse(data);
        } catch (e) {
            return;
        }

        setStats({
            memory: values.memory_bytes || 0,
            cpu: values.cpu_absolute || 0,
            disk: values.disk_bytes || 0,
            uptime: values.uptime || 0,
        });
    });

    const isLow = useMemo(() => {
        const uptimeSec = (stats.uptime || 0) / 1000;
        if (uptimeSec <= 300) {
            return false;
        }

        const cpuOver = limits.cpu > 0 && (stats.cpu / limits.cpu) > 0.95;
        const memLimitBytes = limits.memory * 1024 * 1024;
        const memOver = memLimitBytes > 0 && (stats.memory / memLimitBytes) > 0.95;
        const diskLimitBytes = limits.disk * 1024 * 1024;
        const diskOver = diskLimitBytes > 0 && (stats.disk / diskLimitBytes) > 0.95;

        return cpuOver || memOver || diskOver;
    }, [stats, limits]);

    if (String(lowResourcesAlert) !== 'true' || !isLow) {
        return null;
    }

    return (
        <div className={'w-full px-4 mt-4 block'}>
            <div className={'mx-auto w-full max-w-[1200px]'}>
                <div className={'bg-danger-200 px-4 py-3 flex items-center gap-x-4 rounded-component'}>
                    <div>
                        <ExclamationIcon className={'w-6 text-danger-50'} />
                    </div>
                    <div>
                        <p className={'text-danger-50 font-medium'}>{t('low-resources')}</p>
                        <p className={'text-sm text-danger-50'}>{t('low-resources-desc')}</p>
                    </div>
                    {alertLink && (
                        <a href={alertLink} target={'_blank'} rel={'noreferrer'} className={'ml-auto'}>
                            <Button.Danger>
                                {t('upgrade-server')}
                            </Button.Danger>
                        </a>
                    )}
                </div>
            </div>
        </div>
    );
};