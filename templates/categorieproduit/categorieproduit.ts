import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class CategorieProduit extends BamboObject {
    id: any;
                                nom: string;
                                        photo: string;
                                        description: string;
                        
    constructor() {
        super();
    }
}
