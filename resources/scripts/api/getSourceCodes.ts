import http from '@/api/http';

export interface SourceCode {
    id: number;
    title: string;
    description: string | null;
    link: string;
    category: string | null;
    thumbnail: string | null;
}

interface SourceCodesApiResponse {
    object: string;
    data: SourceCode[];
}

export default (): Promise<SourceCode[]> => {
    return new Promise((resolve, reject) => {
        http.get<SourceCodesApiResponse>('/api/client/source-codes')
            .then(({ data }) => resolve(Array.isArray(data?.data) ? data.data : []))
            .catch(reject);
    });
};
