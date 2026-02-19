import { CSSProperties } from 'react';

export const styles: Record<string, CSSProperties> = {
    centeredLayout: {
        alignItems: 'center',
        background: '#f5f5f5',
        boxSizing: 'border-box',
        display: 'flex',
        justifyContent: 'center',
        margin: 0,
        minHeight: '100vh',
        padding: '16px',
    },
    card: {
        background: '#fff',
        border: '1px solid #ddd',
        borderRadius: '8px',
        boxSizing: 'border-box',
        maxWidth: '360px',
        padding: '24px',
        width: '100%',
    },
    title: {
        fontFamily: 'Arial, sans-serif',
        fontSize: '24px',
        margin: '0 0 16px',
    },
    subtitle: {
        fontFamily: 'Arial, sans-serif',
        margin: '0 0 16px',
    },
    form: {
        display: 'grid',
        gap: '12px',
    },
    label: {
        display: 'grid',
        fontFamily: 'Arial, sans-serif',
        fontSize: '14px',
        gap: '6px',
    },
    input: {
        border: '1px solid #ccc',
        borderRadius: '4px',
        boxSizing: 'border-box',
        padding: '10px',
        width: '100%',
    },
    primaryButton: {
        background: '#111',
        border: 0,
        borderRadius: '4px',
        color: '#fff',
        cursor: 'pointer',
        padding: '10px',
        width: '100%',
    },
    error: {
        color: '#b00020',
        fontFamily: 'Arial, sans-serif',
        fontSize: '14px',
        margin: '0 0 12px',
    },
};
