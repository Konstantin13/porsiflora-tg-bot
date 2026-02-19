import { createRoot } from 'react-dom/client';

import { AppRoot } from '@/components/AppRoot';
import { getPageData } from '@/bootstrap';

const container = document.getElementById('app');

if (!container) {
    throw new Error('Root container #app not found');
}

const data = getPageData();
createRoot(container).render(<AppRoot data={data} />);
