import { DashboardPage } from '@/pages/DashboardPage';
import { LoginPage } from '@/pages/LoginPage';
import { TelegramSettingsPage } from '@/pages/TelegramSettingsPage';
import { PageData } from '@/types/page-data';

type AppRootProps = {
    data: PageData;
};

export function AppRoot({ data }: AppRootProps) {
    if (data.page === 'login') {
        return <LoginPage data={data} />;
    }

    if (data.page === 'telegram-settings') {
        return <TelegramSettingsPage data={data} />;
    }

    return <DashboardPage data={data} />;
}
