import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { AvoirService } from '../avoir.service';
import { DialogService } from 'primeng/api';
import { AvoirNewComponent } from '../avoir-new/avoir-new.component';
import { Avoir } from '../avoir';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-avoir-picklist',
  templateUrl: './avoir-picklist.component.html',
  styleUrls: ['./avoir-picklist.component.css'],
  providers: [DialogService]
})
export class AvoirPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public avoirSrv: AvoirService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(avoirSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(AvoirNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Avoir) => {
      if (item) {
        this.items = [item, ...this.items];
        this.avoirSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
