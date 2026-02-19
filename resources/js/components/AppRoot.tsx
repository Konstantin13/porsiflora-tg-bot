import { DashboardPage } from '@/pages/DashboardPage';
import { LoginPage } from '@/pages/LoginPage';
import { PageData } from '@/types/page-data';

type AppRootProps = {
    data: PageData;
};

export function AppRoot({ data }: AppRootProps) {
    if (data.page === 'login') {
        return <LoginPage data={data} />;
    }

    return <DashboardPage data={data} />;
}
