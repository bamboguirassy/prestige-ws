import { Component, OnInit, OnDestroy } from '@angular/core';
import { CaracteristiqueCategorie } from '../caracteristiquecategorie';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { CaracteristiqueCategorieService } from '../caracteristiquecategorie.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './caracteristiquecategorie-show.component.html',
  styleUrls: ['./caracteristiquecategorie-show.component.css']
})
export class CaracteristiqueCategorieShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: CaracteristiqueCategorie;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public caracteristiqueCategorieSrv: CaracteristiqueCategorieService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, caracteristiqueCategorieSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


