import { useEffect, useState } from 'react';

import { styles } from '@/styles/common';
import { TelegramSettingsPageData } from '@/types/page-data';

type TelegramSettingsPageProps = {
    data: TelegramSettingsPageData;
};

type TelegramStatus = {
    enabled: boolean;
    chatId: string | null;
    lastSentAt: string | null;
    sentCount: number;
    failedCount: number;
};

type TelegramStatusPayload = TelegramStatus | { data?: TelegramStatus };

const TEST_ORDER_NUMBER = `TEST-${Math.random().toString(36).slice(2, 8).toUpperCase()}`;
const TEST_ORDER_TOTAL = Number((Math.random() * 400 + 100).toFixed(2));
const TEST_CUSTOMER_NAME = `Тест ${Math.random().toString(36).slice(2, 7)}`;

function extractTelegramStatus(payload: TelegramStatusPayload): TelegramStatus | null {
    if ('enabled' in payload) {
        return payload;
    }

    return payload.data ?? null;
}

export function TelegramSettingsPage({ data }: TelegramSettingsPageProps) {
    const [botToken, setBotToken] = useState('');
    const [chatId, setChatId] = useState('');
    const [enabled, setEnabled] = useState(false);
    const [status, setStatus] = useState<TelegramStatus | null>(null);
    const [isStatusLoading, setIsStatusLoading] = useState(true);
    const [isSaving, setIsSaving] = useState(false);
    const [isCreatingOrder, setIsCreatingOrder] = useState(false);
    const [error, setError] = useState('');
    const [saveMessage, setSaveMessage] = useState('');
    const [orderMessage, setOrderMessage] = useState('');

    useEffect(() => {
        let isCancelled = false;

        const loadStatus = async () => {
            try {
                const response = await fetch(data.statusUrl);

                if (!response.ok) {
                    throw new Error('Не удалось загрузить статус.');
                }

                const payload = (await response.json()) as TelegramStatusPayload;
                const nextStatus = extractTelegramStatus(payload);

                if (!isCancelled && nextStatus) {
                    setStatus(nextStatus);
                    setEnabled(nextStatus.enabled);
                    setError('');
                }
            } catch {
                if (!isCancelled) {
                    setError('Не удалось загрузить статус.');
                }
            } finally {
                if (!isCancelled) {
                    setIsStatusLoading(false);
                }
            }
        };

        loadStatus();

        return () => {
            isCancelled = true;
        };
    }, [data.statusUrl]);

    const handleSave = async () => {
        setIsSaving(true);
        setError('');
        setSaveMessage('');
        setOrderMessage('');

        try {
            const response = await fetch(data.connectUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    botToken,
                    chatId,
                    enabled,
                }),
            });

            if (!response.ok) {
                throw new Error('Не удалось сохранить настройки.');
            }

            const statusResponse = await fetch(data.statusUrl);

            if (statusResponse.ok) {
                const statusPayload = (await statusResponse.json()) as TelegramStatusPayload;
                const nextStatus = extractTelegramStatus(statusPayload);
                if (nextStatus) {
                    setStatus(nextStatus);
                    setEnabled(nextStatus.enabled);
                }
            }

            setSaveMessage('Настройки сохранены.');
        } catch {
            setError('Не удалось сохранить настройки.');
        } finally {
            setIsSaving(false);
        }
    };

    const handleCreateTestOrder = async () => {
        setIsCreatingOrder(true);
        setError('');
        setSaveMessage('');
        setOrderMessage('');

        try {
            const response = await fetch(data.ordersUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    number: TEST_ORDER_NUMBER,
                    total: TEST_ORDER_TOTAL,
                    customerName: TEST_CUSTOMER_NAME,
                }),
            });

            if (!response.ok) {
                throw new Error('Не удалось создать тестовый заказ.');
            }

            const payload = (await response.json()) as { sendStatus?: string; data?: { sendStatus?: string } };
            const sendStatus = payload.sendStatus ?? payload.data?.sendStatus ?? 'unknown';
            setOrderMessage(`Тестовый заказ отправлен. sendStatus: ${sendStatus}.`);

            const statusResponse = await fetch(data.statusUrl);
            if (statusResponse.ok) {
                const statusPayload = (await statusResponse.json()) as TelegramStatusPayload;
                const nextStatus = extractTelegramStatus(statusPayload);
                if (nextStatus) {
                    setStatus(nextStatus);
                    setEnabled(nextStatus.enabled);
                }
            }
        } catch {
            setError('Не удалось создать тестовый заказ.');
        } finally {
            setIsCreatingOrder(false);
        }
    };

    const lastSentLabel = status?.lastSentAt
        ? new Date(status.lastSentAt).toLocaleString('ru-RU')
        : 'Нет отправок';

    return (
        <main style={styles.centeredLayout}>
            <section style={styles.dashboardCard}>
                <button
                    type="button"
                    onClick={() => {
                        window.location.href = data.backUrl;
                    }}
                    style={styles.backButton}
                >
                    Назад
                </button>

                <h1 style={styles.title}>Настройка Telegram</h1>
                <p style={styles.subtitle}>Магазин: {data.shopName}</p>

                <div style={styles.form}>
                    <label style={styles.label}>
                        Bot Token
                        <input
                            type="text"
                            value={botToken}
                            onChange={(event) => setBotToken(event.target.value)}
                            style={styles.input}
                            placeholder="123456:ABCDEF..."
                        />
                    </label>

                    <label style={styles.label}>
                        Chat ID
                        <input
                            type="text"
                            value={chatId}
                            onChange={(event) => setChatId(event.target.value)}
                            style={styles.input}
                            placeholder="123456789"
                        />
                    </label>

                    <label style={styles.checkboxLabel}>
                        <input
                            type="checkbox"
                            checked={enabled}
                            onChange={(event) => setEnabled(event.target.checked)}
                        />
                        Включено
                    </label>

                    <button type="button" onClick={handleSave} style={styles.primaryButton} disabled={isSaving}>
                        {isSaving ? 'Сохранение...' : 'Сохранить'}
                    </button>
                </div>

                {error && <p style={styles.error}>{error}</p>}
                {saveMessage && <p style={styles.success}>{saveMessage}</p>}
                {orderMessage && <p style={styles.success}>{orderMessage}</p>}

                <button
                    type="button"
                    onClick={handleCreateTestOrder}
                    style={styles.primaryButton}
                    disabled={isCreatingOrder}
                >
                    {isCreatingOrder ? 'Создание заказа...' : 'Сделать тестовый заказ'}
                </button>

                <section style={styles.statusCard}>
                    <h2 style={styles.subtitle}>Статус</h2>

                    {isStatusLoading ? (
                        <p style={styles.subtitle}>Загрузка статуса...</p>
                    ) : (
                        <>
                            <p style={styles.subtitle}>
                                enabled: {status?.enabled ? 'true' : 'false'}
                            </p>
                            <p style={styles.subtitle}>
                                chatId: {status?.chatId ?? 'Не задан'}
                            </p>
                            <p style={styles.subtitle}>
                                lastSentAt: {lastSentLabel}
                            </p>
                            <p style={styles.subtitle}>
                                sent/failed за 7 дней: {status?.sentCount ?? 0}/{status?.failedCount ?? 0}
                            </p>
                        </>
                    )}
                </section>

                <p style={styles.hint}>
                    Chat ID можно узнать через Telegram-бота @myidbot.
                </p>
            </section>
        </main>
    );
}
