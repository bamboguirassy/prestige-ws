import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { ProduitCategorise } from '../produitcategorise';
import { ProduitCategoriseService } from '../produitcategorise.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-produitcategorise-new',
  templateUrl: './produitcategorise-new.component.html',
  styleUrls: ['./produitcategorise-new.component.css'],
  providers: [DialogService]
})
export class ProduitCategoriseNewComponent extends BamboAbstractNewComponent<ProduitCategorise> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public produitCategoriseSrv: ProduitCategoriseService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, produitCategoriseSrv, connectionService);
    this.item = new ProduitCategorise();
  }

  ngOnInit() {}

  prepareCreation() {}

}
