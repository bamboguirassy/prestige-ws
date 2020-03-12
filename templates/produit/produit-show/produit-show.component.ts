import { Component, OnInit, OnDestroy } from '@angular/core';
import { Produit } from '../produit';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ProduitService } from '../produit.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './produit-show.component.html',
  styleUrls: ['./produit-show.component.css']
})
export class ProduitShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Produit;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public produitSrv: ProduitService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, produitSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


