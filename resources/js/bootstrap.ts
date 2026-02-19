import { PageData } from '@/types/page-data';

declare global {
    interface Window {
        __APP_DATA__?: PageData;
    }
}

export function getPageData(): PageData {
    const data = window.__APP_DATA__;

    if (!data) {
        throw new Error('Missing bootstrap data in window.__APP_DATA__');
    }

    return data;
}
