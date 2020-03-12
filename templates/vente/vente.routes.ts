import { Route } from '@angular/router';
import { VenteListComponent } from './vente-list/vente-list.component';

const venteRoutes: Route = {
    path: 'vente',
    children: [
        { path: '', component: VenteListComponent }
    ]
};

export { venteRoutes };
