import { Route } from '@angular/router';
import { ValeurCaracteristiqueListComponent } from './valeurcaracteristique-list/valeurcaracteristique-list.component';

const valeurCaracteristiqueRoutes: Route = {
    path: 'valeurcaracteristique',
    children: [
        { path: '', component: ValeurCaracteristiqueListComponent }
    ]
};

export { valeurCaracteristiqueRoutes };
