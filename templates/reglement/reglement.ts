import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Reglement extends BamboObject {
    id: any;
                                montant: string;
                                        date: string;
                                        montantRestant: string;
                                        commande: string;
                                        montantDonne: string;
                                        montantRetourne: string;
                        
    constructor() {
        super();
    }
}
