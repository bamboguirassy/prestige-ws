import { Route } from '@angular/router';
import { ModeleListComponent } from './modele-list/modele-list.component';

const modeleRoutes: Route = {
    path: 'modele',
    children: [
        { path: '', component: ModeleListComponent }
    ]
};

export { modeleRoutes };
