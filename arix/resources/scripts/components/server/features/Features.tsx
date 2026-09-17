import React, { useMemo } from 'react';
import features from './index';
import { getObjectKeys } from '@/lib/objects';

type ListItems = [string, React.ComponentType][];

export default ({ enabled = [] }: { enabled?: string[] }) => {
    const mapped: ListItems = useMemo(() => {
        const safeEnabled = Array.isArray(enabled) ? enabled : [];
        return getObjectKeys(features)
            .filter((key) => safeEnabled.map((v) => v.toLowerCase()).includes(key.toLowerCase()))
            .reduce((arr, key) => [...arr, [key, features[key]]], [] as ListItems);
    }, [enabled]);

    return (
        <React.Suspense fallback={null}>
            {mapped.map(([key, Component]) => (
                <Component key={key} />
            ))}
        </React.Suspense>
    );
};
