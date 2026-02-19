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
};

export type PageData = LoginPageData | DashboardPageData;
