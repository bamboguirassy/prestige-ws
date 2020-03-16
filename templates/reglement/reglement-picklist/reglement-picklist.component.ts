import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { ReglementService } from '../reglement.service';
import { DialogService } from 'primeng/api';
import { ReglementNewComponent } from '../reglement-new/reglement-new.component';
import { Reglement } from '../reglement';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-reglement-picklist',
  templateUrl: './reglement-picklist.component.html',
  styleUrls: ['./reglement-picklist.component.css'],
  providers: [DialogService]
})
export class ReglementPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public reglementSrv: ReglementService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(reglementSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ReglementNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Reglement) => {
      if (item) {
        this.items = [item, ...this.items];
        this.reglementSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
