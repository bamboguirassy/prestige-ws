import { Route } from '@angular/router';
import { MoyenPaiementListComponent } from './moyenpaiement-list/moyenpaiement-list.component';

const moyenPaiementRoutes: Route = {
    path: 'moyenpaiement',
    children: [
        { path: '', component: MoyenPaiementListComponent }
    ]
};

export { moyenPaiementRoutes };
