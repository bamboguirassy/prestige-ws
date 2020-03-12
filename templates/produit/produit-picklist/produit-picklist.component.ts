import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { ProduitService } from '../produit.service';
import { DialogService } from 'primeng/api';
import { ProduitNewComponent } from '../produit-new/produit-new.component';
import { Produit } from '../produit';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-produit-picklist',
  templateUrl: './produit-picklist.component.html',
  styleUrls: ['./produit-picklist.component.css'],
  providers: [DialogService]
})
export class ProduitPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public produitSrv: ProduitService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(produitSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ProduitNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Produit) => {
      if (item) {
        this.items = [item, ...this.items];
        this.produitSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
