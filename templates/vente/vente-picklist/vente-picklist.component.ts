import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { VenteService } from '../vente.service';
import { DialogService } from 'primeng/api';
import { VenteNewComponent } from '../vente-new/vente-new.component';
import { Vente } from '../vente';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-vente-picklist',
  templateUrl: './vente-picklist.component.html',
  styleUrls: ['./vente-picklist.component.css'],
  providers: [DialogService]
})
export class VentePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public venteSrv: VenteService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(venteSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(VenteNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Vente) => {
      if (item) {
        this.items = [item, ...this.items];
        this.venteSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
