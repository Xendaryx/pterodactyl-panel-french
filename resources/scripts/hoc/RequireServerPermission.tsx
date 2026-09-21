import React from 'react';
import Can from '@/components/elements/Can';
import { ServerError } from '@/components/elements/ScreenBlock';

export interface RequireServerPermissionProps {
    permissions: string | string[];
}

const RequireServerPermission: React.FC<RequireServerPermissionProps> = ({ children, permissions }) => {
    return (
        <Can
            action={permissions}
            renderOnError={
                <ServerError title={'Accès refusé'} message={'Vous n’avez pas l’autorisation d’accéder à cette page.'} />
            }
        >
            {children}
        </Can>
    );
};

export default RequireServerPermission;
