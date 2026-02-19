import { useEffect, useState } from 'react';

import { styles } from '@/styles/common';
import { DashboardPageData } from '@/types/page-data';

type DashboardPageProps = {
    data: DashboardPageData;
};

type Shop = {
    id: number;
    name: string;
};

export function DashboardPage({ data }: DashboardPageProps) {
    const [shops, setShops] = useState<Shop[]>([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        let isCancelled = false;

        const loadShops = async () => {
            try {
                const response = await fetch(data.shopsUrl);

                if (!response.ok) {
                    throw new Error('Не удалось загрузить магазины.');
                }

                const payload = (await response.json()) as Shop[] | { data?: Shop[] };
                const list = Array.isArray(payload)
                    ? payload
                    : Array.isArray(payload.data)
                      ? payload.data
                      : [];

                if (!isCancelled) {
                    setShops(list);
                    setError('');
                }
            } catch {
                if (!isCancelled) {
                    setError('Не удалось загрузить магазины.');
                }
            } finally {
                if (!isCancelled) {
                    setIsLoading(false);
                }
            }
        };

        loadShops();

        return () => {
            isCancelled = true;
        };
    }, [data.shopsUrl]);

    return (
        <main style={styles.centeredLayout}>
            <section style={styles.dashboardCard}>
                <h1 style={styles.title}>Dashboard</h1>
                <p style={styles.subtitle}>Вы вошли как: {data.userName}</p>

                <h2 style={styles.subtitle}>Список магазинов</h2>

                {isLoading && <p style={styles.subtitle}>Загрузка...</p>}
                {error && <p style={styles.error}>{error}</p>}

                {!isLoading && !error && (
                    shops.length > 0 ? (
                        <ul style={styles.shopList}>
                            {shops.map((shop) => (
                                <li key={shop.id} style={styles.shopListItem}>
                                    {shop.id}. {shop.name}
                                </li>
                            ))}
                        </ul>
                    ) : (
                        <p style={styles.subtitle}>Магазинов пока нет.</p>
                    )
                )}

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
