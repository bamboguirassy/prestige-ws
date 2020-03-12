import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class VenteProduit extends BamboObject {
    id: any;
                                prixUnitaire: string;
                                        quantite: string;
                                        montantTotal: string;
                        
    constructor() {
        super();
    }
}
