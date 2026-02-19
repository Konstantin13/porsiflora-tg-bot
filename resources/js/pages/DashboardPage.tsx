import { styles } from '@/styles/common';
import { DashboardPageData } from '@/types/page-data';

type DashboardPageProps = {
    data: DashboardPageData;
};

export function DashboardPage({ data }: DashboardPageProps) {
    return (
        <main style={styles.centeredLayout}>
            <section style={styles.card}>
                <h1 style={styles.title}>Dashboard</h1>
                <p style={styles.subtitle}>Вы вошли как: {data.userName}</p>

                <form method="POST" action={data.logoutAction}>
                    <input type="hidden" name="_token" value={data.csrfToken} />
                    <button type="submit" style={styles.primaryButton}>
                        Выйти
                    </button>
                </form>
            </section>
        </main>
    );
}
