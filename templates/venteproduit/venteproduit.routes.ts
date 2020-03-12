import { Route } from '@angular/router';
import { VenteProduitListComponent } from './venteproduit-list/venteproduit-list.component';

const venteProduitRoutes: Route = {
    path: 'venteproduit',
    children: [
        { path: '', component: VenteProduitListComponent }
    ]
};

export { venteProduitRoutes };
