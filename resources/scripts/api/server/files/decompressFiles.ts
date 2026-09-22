import http from '@/api/http';

export default async (uuid: string, directory: string, file: string): Promise<void> => {
    await http.post(
        `/api/client/servers/${uuid}/files/decompress`,
        { root: directory, file },
        {
            timeout: 300000,
            timeoutErrorMessage:
                'La décompression de cette archive semble prendre plus de temps que prévu. Une fois terminée, les fichiers décompressés apparaîtront.',
        }
    );
};
