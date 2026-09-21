import React, { useEffect, useState } from 'react';
import { ServerContext } from '@/state/server';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import reinstallServer from '@/api/server/reinstallServer';
import { Actions, useStoreActions } from 'easy-peasy';
import { ApplicationStore } from '@/state';
import { httpErrorToHuman } from '@/api/http';
import tw from 'twin.macro';
import { Button } from '@/components/elements/button/index';
import { Dialog } from '@/components/elements/dialog';

export default () => {
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const skipScripts = ServerContext.useStoreState((state) => state.server.data!.skipScripts);
    const [modalVisible, setModalVisible] = useState(false);
    const { addFlash, clearFlashes } = useStoreActions((actions: Actions<ApplicationStore>) => actions.flashes);

    const reinstall = () => {
        clearFlashes('settings');
        reinstallServer(uuid)
            .then(() => {
                addFlash({
                    key: 'settings',
                    type: 'success',
                    message: 'La réinstallation de votre serveur a commencé.',
                });
            })
            .catch((error) => {
                console.error(error);

                addFlash({ key: 'settings', type: 'error', message: httpErrorToHuman(error) });
            })
            .then(() => setModalVisible(false));
    };

    useEffect(() => {
        clearFlashes();
    }, []);

    if (skipScripts) {
        return (
            <TitledGreyBox title={'Réinstaller le serveur'}>
                <p css={tw`text-sm`}>
                    La réinstallation de ce serveur est désactivée car il est configuré pour ignorer le script
                    d’installation de son Egg. Pour réinstaller ce serveur, contactez un administrateur.
                </p>
            </TitledGreyBox>
        );
    }

    return (
        <TitledGreyBox title={'Réinstaller le serveur'} css={tw`relative`}>
            <Dialog.Confirm
                open={modalVisible}
                title={'Confirmer la réinstallation du serveur'}
                confirm={'Oui, réinstaller le serveur'}
                onClose={() => setModalVisible(false)}
                onConfirmed={reinstall}
            >
                Votre serveur sera arrêté et certains fichiers pourront être supprimés ou modifiés pendant cette opération.
                Voulez-vous vraiment continuer ?
            </Dialog.Confirm>
            <p css={tw`text-sm`}>
                La réinstallation arrêtera votre serveur puis exécutera de nouveau le script d’installation initial.
                &nbsp;
                <strong css={tw`font-medium`}>
                    Certains fichiers peuvent être supprimés ou modifiés pendant cette opération. Sauvegardez vos données
                    avant de continuer.
                </strong>
            </p>
            <div css={tw`mt-6 text-right`}>
                <Button.Danger variant={Button.Variants.Secondary} onClick={() => setModalVisible(true)}>
                    Réinstaller le serveur
                </Button.Danger>
            </div>
        </TitledGreyBox>
    );
};
