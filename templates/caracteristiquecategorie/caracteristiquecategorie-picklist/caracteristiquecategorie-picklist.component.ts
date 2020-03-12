import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { CaracteristiqueCategorieService } from '../caracteristiquecategorie.service';
import { DialogService } from 'primeng/api';
import { CaracteristiqueCategorieNewComponent } from '../caracteristiquecategorie-new/caracteristiquecategorie-new.component';
import { CaracteristiqueCategorie } from '../caracteristiquecategorie';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-caracteristiquecategorie-picklist',
  templateUrl: './caracteristiquecategorie-picklist.component.html',
  styleUrls: ['./caracteristiquecategorie-picklist.component.css'],
  providers: [DialogService]
})
export class CaracteristiqueCategoriePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public caracteristiqueCategorieSrv: CaracteristiqueCategorieService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(caracteristiqueCategorieSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(CaracteristiqueCategorieNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: CaracteristiqueCategorie) => {
      if (item) {
        this.items = [item, ...this.items];
        this.caracteristiqueCategorieSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
