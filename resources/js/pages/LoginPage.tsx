import { FormEvent } from 'react';

import { styles } from '@/styles/common';
import { LoginPageData } from '@/types/page-data';

type LoginPageProps = {
    data: LoginPageData;
};

export function LoginPage({ data }: LoginPageProps) {
    const onSubmit = (event: FormEvent<HTMLFormElement>): void => {
        const form = event.currentTarget;
        const loginInput = form.querySelector<HTMLInputElement>('input[name="login"]');

        if (loginInput) {
            loginInput.value = loginInput.value.trim();
        }
    };

    return (
        <main style={styles.centeredLayout}>
            <section style={styles.card}>
                <h1 style={styles.title}>Авторизация</h1>

                {data.hasLoginError ? <p style={styles.error}>Неверный логин или пароль.</p> : null}

                <form method="POST" action={data.loginAction} onSubmit={onSubmit} style={styles.form}>
                    <input type="hidden" name="_token" value={data.csrfToken} />

                    <label style={styles.label}>
                        Логин
                        <input
                            type="text"
                            name="login"
                            defaultValue={data.oldLogin}
                            required
                            autoFocus
                            style={styles.input}
                        />
                    </label>

                    <label style={styles.label}>
                        Пароль
                        <input type="password" name="password" required style={styles.input} />
                    </label>

                    <button type="submit" style={styles.primaryButton}>
                        Войти
                    </button>
                </form>
            </section>
        </main>
    );
}
