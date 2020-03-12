import { Route } from '@angular/router';
import { EntrepriseListComponent } from './entreprise-list/entreprise-list.component';

const entrepriseRoutes: Route = {
    path: 'entreprise',
    children: [
        { path: '', component: EntrepriseListComponent }
    ]
};

export { entrepriseRoutes };
