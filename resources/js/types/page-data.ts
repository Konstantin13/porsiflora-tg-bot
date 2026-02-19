export type SharedData = {
    csrfToken: string;
};

export type LoginPageData = SharedData & {
    page: 'login';
    hasLoginError: boolean;
    oldLogin: string;
    loginAction: string;
};

export type DashboardPageData = SharedData & {
    page: 'dashboard';
    userName: string;
    logoutAction: string;
    shopsUrl: string;
};

export type TelegramSettingsPageData = SharedData & {
    page: 'telegram-settings';
    shopId: number;
    shopName: string;
    backUrl: string;
    connectUrl: string;
    statusUrl: string;
    ordersUrl: string;
};

export type PageData = LoginPageData | DashboardPageData | TelegramSettingsPageData;
