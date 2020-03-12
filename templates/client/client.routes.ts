import { Route } from '@angular/router';
import { ClientListComponent } from './client-list/client-list.component';

const clientRoutes: Route = {
    path: 'client',
    children: [
        { path: '', component: ClientListComponent }
    ]
};

export { clientRoutes };
