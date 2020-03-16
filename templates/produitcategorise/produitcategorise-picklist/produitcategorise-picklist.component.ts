import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { ProduitCategoriseService } from '../produitcategorise.service';
import { DialogService } from 'primeng/api';
import { ProduitCategoriseNewComponent } from '../produitcategorise-new/produitcategorise-new.component';
import { ProduitCategorise } from '../produitcategorise';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-produitcategorise-picklist',
  templateUrl: './produitcategorise-picklist.component.html',
  styleUrls: ['./produitcategorise-picklist.component.css'],
  providers: [DialogService]
})
export class ProduitCategorisePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public produitCategoriseSrv: ProduitCategoriseService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(produitCategoriseSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ProduitCategoriseNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: ProduitCategorise) => {
      if (item) {
        this.items = [item, ...this.items];
        this.produitCategoriseSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
