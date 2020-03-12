import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Produit } from '../produit';
import { ProduitService } from '../produit.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-produit-new',
  templateUrl: './produit-new.component.html',
  styleUrls: ['./produit-new.component.css'],
  providers: [DialogService]
})
export class ProduitNewComponent extends BamboAbstractNewComponent<Produit> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public produitSrv: ProduitService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, produitSrv, connectionService);
    this.item = new Produit();
  }

  ngOnInit() {}

  prepareCreation() {}

}
