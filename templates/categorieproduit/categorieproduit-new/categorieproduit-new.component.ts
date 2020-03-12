import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { CategorieProduit } from '../categorieproduit';
import { CategorieProduitService } from '../categorieproduit.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-categorieproduit-new',
  templateUrl: './categorieproduit-new.component.html',
  styleUrls: ['./categorieproduit-new.component.css'],
  providers: [DialogService]
})
export class CategorieProduitNewComponent extends BamboAbstractNewComponent<CategorieProduit> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public categorieProduitSrv: CategorieProduitService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, categorieProduitSrv, connectionService);
    this.item = new CategorieProduit();
  }

  ngOnInit() {}

  prepareCreation() {}

}
