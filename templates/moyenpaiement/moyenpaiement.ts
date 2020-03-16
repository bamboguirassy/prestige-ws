import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class MoyenPaiement extends BamboObject {
    id: any;
                                nom: string;
                                        code: string;
                                        description: string;
                        
    constructor() {
        super();
    }
}
