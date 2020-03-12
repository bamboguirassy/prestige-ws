import { Route } from '@angular/router';
import { ProduitListComponent } from './produit-list/produit-list.component';

const produitRoutes: Route = {
    path: 'produit',
    children: [
        { path: '', component: ProduitListComponent }
    ]
};

export { produitRoutes };
