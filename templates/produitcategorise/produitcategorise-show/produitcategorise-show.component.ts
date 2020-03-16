import { Component, OnInit, OnDestroy } from '@angular/core';
import { ProduitCategorise } from '../produitcategorise';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ProduitCategoriseService } from '../produitcategorise.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './produitcategorise-show.component.html',
  styleUrls: ['./produitcategorise-show.component.css']
})
export class ProduitCategoriseShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: ProduitCategorise;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public produitCategoriseSrv: ProduitCategoriseService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, produitCategoriseSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


