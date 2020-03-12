import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { CaracteristiqueCategorie } from '../caracteristiquecategorie';
import { CaracteristiqueCategorieService } from '../caracteristiquecategorie.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-caracteristiquecategorie-new',
  templateUrl: './caracteristiquecategorie-new.component.html',
  styleUrls: ['./caracteristiquecategorie-new.component.css'],
  providers: [DialogService]
})
export class CaracteristiqueCategorieNewComponent extends BamboAbstractNewComponent<CaracteristiqueCategorie> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public caracteristiqueCategorieSrv: CaracteristiqueCategorieService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, caracteristiqueCategorieSrv, connectionService);
    this.item = new CaracteristiqueCategorie();
  }

  ngOnInit() {}

  prepareCreation() {}

}
