import { createRoot } from 'react-dom/client';

const container = document.getElementById('app');

if (!container) {
    throw new Error('Root container #app not found');
}

createRoot(container).render(<h1>hello world</h1>);
