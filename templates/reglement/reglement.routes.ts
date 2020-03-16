import { Route } from '@angular/router';
import { ReglementListComponent } from './reglement-list/reglement-list.component';

const reglementRoutes: Route = {
    path: 'reglement',
    children: [
        { path: '', component: ReglementListComponent }
    ]
};

export { reglementRoutes };
