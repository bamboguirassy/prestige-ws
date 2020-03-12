import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { ModeleService } from '../modele.service';
import { DialogService } from 'primeng/api';
import { ModeleNewComponent } from '../modele-new/modele-new.component';
import { Modele } from '../modele';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-modele-picklist',
  templateUrl: './modele-picklist.component.html',
  styleUrls: ['./modele-picklist.component.css'],
  providers: [DialogService]
})
export class ModelePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public modeleSrv: ModeleService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(modeleSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ModeleNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Modele) => {
      if (item) {
        this.items = [item, ...this.items];
        this.modeleSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
