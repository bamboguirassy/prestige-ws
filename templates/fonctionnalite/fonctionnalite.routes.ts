import { Route } from '@angular/router';
import { FonctionnaliteListComponent } from './fonctionnalite-list/fonctionnalite-list.component';

const fonctionnaliteRoutes: Route = {
    path: 'fonctionnalite',
    children: [
        { path: '', component: FonctionnaliteListComponent }
    ]
};

export { fonctionnaliteRoutes };
