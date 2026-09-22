import React from 'react';
import { ServerContext } from '@/state/server';
import ScreenBlock from '@/components/elements/ScreenBlock';
import ServerInstallSvg from '@/assets/images/server_installing.svg';
import ServerErrorSvg from '@/assets/images/server_error.svg';
import ServerRestoreSvg from '@/assets/images/server_restore.svg';

export default () => {
    const status = ServerContext.useStoreState((state) => state.server.data?.status || null);
    const isTransferring = ServerContext.useStoreState((state) => state.server.data?.isTransferring || false);
    const isNodeUnderMaintenance = ServerContext.useStoreState(
        (state) => state.server.data?.isNodeUnderMaintenance || false
    );

    return status === 'installing' || status === 'install_failed' || status === 'reinstall_failed' ? (
        <ScreenBlock
            title={'Installation en cours'}
            image={ServerInstallSvg}
            message={'Votre serveur devrait être prêt prochainement. Veuillez réessayer dans quelques minutes.'}
        />
    ) : status === 'suspended' ? (
        <ScreenBlock
            title={'Serveur suspendu'}
            image={ServerErrorSvg}
            message={'Ce serveur est suspendu et n’est pas accessible.'}
        />
    ) : isNodeUnderMaintenance ? (
        <ScreenBlock
            title={'Nœud en maintenance'}
            image={ServerErrorSvg}
            message={'Le nœud de ce serveur est actuellement en maintenance.'}
        />
    ) : (
        <ScreenBlock
            title={isTransferring ? 'Transfert en cours' : 'Restauration depuis une sauvegarde'}
            image={ServerRestoreSvg}
            message={
                isTransferring
                    ? 'Votre serveur est en cours de transfert vers un nouveau nœud. Veuillez réessayer plus tard.'
                    : 'Votre serveur est actuellement en cours de restauration depuis une sauvegarde. Veuillez réessayer dans quelques minutes.'
            }
        />
    );
};
