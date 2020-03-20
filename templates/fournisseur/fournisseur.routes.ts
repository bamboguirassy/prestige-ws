import { Route } from '@angular/router';
import { FournisseurListComponent } from './fournisseur-list/fournisseur-list.component';

const fournisseurRoutes: Route = {
    path: 'fournisseur',
    children: [
        { path: '', component: FournisseurListComponent }
    ]
};

export { fournisseurRoutes };
