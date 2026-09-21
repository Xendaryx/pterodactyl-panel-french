import React, { useEffect, useState } from 'react';
import { ServerContext } from '@/state/server';
import Modal from '@/components/elements/Modal';
import tw from 'twin.macro';
import Button from '@/components/elements/Button';
import FlashMessageRender from '@/components/FlashMessageRender';
import useFlash from '@/plugins/useFlash';
import { SocketEvent } from '@/components/server/events';
import { useStoreState } from 'easy-peasy';

const SteamDiskSpaceFeature = () => {
    const [visible, setVisible] = useState(false);
    const [loading] = useState(false);

    const status = ServerContext.useStoreState((state) => state.status.value);
    const { clearFlashes } = useFlash();
    const { connected, instance } = ServerContext.useStoreState((state) => state.socket);
    const isAdmin = useStoreState((state) => state.user.data!.rootAdmin);

    useEffect(() => {
        if (!connected || !instance || status === 'running') return;

        const errors = ['steamcmd needs 250mb of free disk space to update', '0x202 after update job'];

        const listener = (line: string) => {
            if (errors.some((p) => line.toLowerCase().includes(p))) {
                setVisible(true);
            }
        };

        instance.addListener(SocketEvent.CONSOLE_OUTPUT, listener);

        return () => {
            instance.removeListener(SocketEvent.CONSOLE_OUTPUT, listener);
        };
    }, [connected, instance, status]);

    useEffect(() => {
        clearFlashes('feature:steamDiskSpace');
    }, []);

    return (
        <Modal
            visible={visible}
            onDismissed={() => setVisible(false)}
            closeOnBackground={false}
            showSpinnerOverlay={loading}
        >
            <FlashMessageRender key={'feature:steamDiskSpace'} css={tw`mb-4`} />
            {isAdmin ? (
                <>
                    <div css={tw`mt-4 sm:flex items-center`}>
                        <h2 css={tw`text-2xl mb-4 text-neutral-100 `}>Espace disque disponible épuisé...</h2>
                    </div>
                    <p css={tw`mt-4`}>
                        Ce serveur ne dispose plus d’espace disque disponible et ne peut pas terminer l’installation
                        ou la mise à jour.
                    </p>
                    <p css={tw`mt-4`}>
                        Vérifiez que la machine dispose de suffisamment d’espace disque en exécutant{' '}
                        <code css={tw`font-mono bg-neutral-900 rounded py-1 px-2`}>df -h</code> sur la machine hébergeant
                        ce serveur. Supprimez des fichiers ou augmentez l’espace disque disponible pour résoudre le problème.
                    </p>
                    <div css={tw`mt-8 sm:flex items-center justify-end`}>
                        <Button onClick={() => setVisible(false)} css={tw`w-full sm:w-auto border-transparent`}>
                            Fermer
                        </Button>
                    </div>
                </>
            ) : (
                <>
                    <div css={tw`mt-4 sm:flex items-center`}>
                        <h2 css={tw`text-2xl mb-4 text-neutral-100`}>Espace disque disponible épuisé...</h2>
                    </div>
                    <p css={tw`mt-4`}>
                        Ce serveur ne dispose plus d’espace disque disponible et ne peut pas terminer l’installation
                        ou la mise à jour. Contactez un administrateur et signalez-lui le manque d’espace disque.
                    </p>
                    <div css={tw`mt-8 sm:flex items-center justify-end`}>
                        <Button onClick={() => setVisible(false)} css={tw`w-full sm:w-auto border-transparent`}>
                            Fermer
                        </Button>
                    </div>
                </>
            )}
        </Modal>
    );
};

export default SteamDiskSpaceFeature;
