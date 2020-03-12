import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { VenteProduitService } from '../venteproduit.service';
import { DialogService } from 'primeng/api';
import { VenteProduitNewComponent } from '../venteproduit-new/venteproduit-new.component';
import { VenteProduit } from '../venteproduit';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-venteproduit-picklist',
  templateUrl: './venteproduit-picklist.component.html',
  styleUrls: ['./venteproduit-picklist.component.css'],
  providers: [DialogService]
})
export class VenteProduitPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public venteProduitSrv: VenteProduitService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(venteProduitSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(VenteProduitNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: VenteProduit) => {
      if (item) {
        this.items = [item, ...this.items];
        this.venteProduitSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
