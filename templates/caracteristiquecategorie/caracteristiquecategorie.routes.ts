import { Route } from '@angular/router';
import { CaracteristiqueCategorieListComponent } from './caracteristiquecategorie-list/caracteristiquecategorie-list.component';

const caracteristiqueCategorieRoutes: Route = {
    path: 'caracteristiquecategorie',
    children: [
        { path: '', component: CaracteristiqueCategorieListComponent }
    ]
};

export { caracteristiqueCategorieRoutes };
