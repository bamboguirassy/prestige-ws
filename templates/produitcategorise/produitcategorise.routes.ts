import { Route } from '@angular/router';
import { ProduitCategoriseListComponent } from './produitcategorise-list/produitcategorise-list.component';

const produitCategoriseRoutes: Route = {
    path: 'produitcategorise',
    children: [
        { path: '', component: ProduitCategoriseListComponent }
    ]
};

export { produitCategoriseRoutes };
