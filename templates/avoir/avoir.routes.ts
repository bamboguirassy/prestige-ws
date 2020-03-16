import { Route } from '@angular/router';
import { AvoirListComponent } from './avoir-list/avoir-list.component';

const avoirRoutes: Route = {
    path: 'avoir',
    children: [
        { path: '', component: AvoirListComponent }
    ]
};

export { avoirRoutes };
