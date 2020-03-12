import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { CaracteristiqueCategorieService } from '../caracteristiquecategorie.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { CaracteristiqueCategorie } from '../caracteristiquecategorie';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './caracteristiquecategorie-edit.component.html',
  styleUrls: ['./caracteristiquecategorie-edit.component.css']
})
export class CaracteristiqueCategorieEditComponent extends BamboAbstractEditComponent<CaracteristiqueCategorie> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public caracteristiqueCategorieSrv: CaracteristiqueCategorieService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, caracteristiqueCategorieSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
