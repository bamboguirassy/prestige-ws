import { Component, OnInit, OnDestroy } from '@angular/core';
import { CategorieProduit } from '../categorieproduit';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { CategorieProduitService } from '../categorieproduit.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './categorieproduit-show.component.html',
  styleUrls: ['./categorieproduit-show.component.css']
})
export class CategorieProduitShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: CategorieProduit;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public categorieProduitSrv: CategorieProduitService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, categorieProduitSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


