import { Route } from '@angular/router';
import { CategorieProduitListComponent } from './categorieproduit-list/categorieproduit-list.component';

const categorieProduitRoutes: Route = {
    path: 'categorieproduit',
    children: [
        { path: '', component: CategorieProduitListComponent }
    ]
};

export { categorieProduitRoutes };
