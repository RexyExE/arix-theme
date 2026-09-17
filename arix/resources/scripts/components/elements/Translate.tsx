import React from 'react';
import { useTranslation } from 'react-i18next';

export default ({ ns, t: key }: { ns: string; t: string }) => {
    const { t } = useTranslation(ns);
    return <>{t(key)}</>;
};
