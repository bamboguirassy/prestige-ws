import { Injectable } from '@angular/core';
import { BamboHttpService } from 'src/app/shared/services/bambo-http.service';
import { BamboAbstractService } from 'src/app/shared/interfaces/bambo-abstract.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Injectable({
  providedIn: 'root'
})
export class <?= $entity_class_name ?>Service extends BamboAbstractService {

  constructor(public httpSrv: BamboHttpService,
              public connectionService: BamboConnectionStatusService) {
    super(httpSrv, connectionService);
    this.setRoutePrefix('<?= strtolower($entity_class_name) ?>');
    this.setResourceName('<?= strtoupper($entity_class_name) ?>');
  }


}
