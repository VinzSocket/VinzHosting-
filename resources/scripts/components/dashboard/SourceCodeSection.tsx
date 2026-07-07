import { useState } from 'react';
import useSWR from 'swr';
import { useStoreState } from 'easy-peasy';
import { useTranslation } from 'react-i18next';
import { FaCode, FaGithub, FaDownload, FaPalette } from 'react-icons/fa6';
import Card from '@/reviactyl/ui/Card';
import Title from '@/reviactyl/ui/Title';
import Modal from '@/reviactyl/elements/Modal';
import { usePersistedState } from '@/plugins/usePersistedState';
import getSourceCodes, { SourceCode } from '@/api/getSourceCodes';

type ButtonStyle = '3d' | 'normal';

const isGithubLink = (link: string) => /github\.com/i.test(link);

const SourceCodeButton = ({ sourceCode, style }: { sourceCode: SourceCode; style: ButtonStyle }) => {
    const { t } = useTranslation('dashboard/index');
    const github = isGithubLink(sourceCode.link);

    const className =
        style === '3d'
            ? 'inline-flex items-center gap-2 rounded-ui bg-blue-500 text-white text-sm font-bold px-4 py-2 border-b-[3px] border-blue-800 shadow-[0_3px_0_0_rgba(0,0,0,0.25)] active:border-b-0 active:translate-y-[3px] active:shadow-none transition-all duration-100 select-none'
            : 'inline-flex items-center gap-2 rounded-ui bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 transition-colors select-none';

    return (
        <a href={sourceCode.link} target='_blank' rel='noopener noreferrer' className={className}>
            {github ? <FaGithub className='w-4 h-4' /> : <FaDownload className='w-4 h-4' />}
            {t('source-codes.view')}
        </a>
    );
};

const SourceCodeCard = ({ sourceCode, style }: { sourceCode: SourceCode; style: ButtonStyle }) => {
    const { t } = useTranslation('dashboard/index');

    return (
        <Card className='flex flex-col overflow-hidden !p-0'>
            <div className='h-32 w-full bg-gray-800 overflow-hidden flex items-center justify-center'>
                {sourceCode.thumbnail ? (
                    <img src={sourceCode.thumbnail} alt={sourceCode.title} className='w-full h-full object-cover' />
                ) : (
                    <FaCode className='w-10 h-10 text-gray-600' />
                )}
            </div>
            <div className='flex flex-col flex-1 gap-2 p-4'>
                <div className='flex items-start justify-between gap-2'>
                    <h3 className='text-base font-semibold text-gray-50 break-words'>{sourceCode.title}</h3>
                    {sourceCode.category && (
                        <span className='flex-shrink-0 text-xs uppercase font-medium bg-gray-800 text-gray-300 rounded-ui px-2 py-1'>
                            {sourceCode.category}
                        </span>
                    )}
                </div>
                <p className='text-sm text-gray-400 flex-1 line-clamp-3'>
                    {sourceCode.description || t('source-codes.no-description')}
                </p>
                <div className='pt-2'>
                    <SourceCodeButton sourceCode={sourceCode} style={style} />
                </div>
            </div>
        </Card>
    );
};

const StyleOptionPreview = ({
    label,
    active,
    style,
    onSelect,
}: {
    label: string;
    active: boolean;
    style: ButtonStyle;
    onSelect: () => void;
}) => {
    const previewClassName =
        style === '3d'
            ? 'inline-flex items-center gap-2 rounded-ui bg-blue-500 text-white text-sm font-bold px-4 py-2 border-b-[3px] border-blue-800 shadow-[0_3px_0_0_rgba(0,0,0,0.25)]'
            : 'inline-flex items-center gap-2 rounded-ui bg-blue-600 text-white text-sm font-medium px-4 py-2';

    return (
        <button
            type='button'
            onClick={onSelect}
            className={`flex-1 flex flex-col items-center gap-3 rounded-ui border p-4 transition-colors ${
                active ? 'border-blue-500 bg-blue-500/10' : 'border-gray-800 hover:border-gray-700'
            }`}
        >
            <span className={previewClassName}>
                <FaDownload className='w-4 h-4' />
                Download
            </span>
            <span className='text-sm text-gray-200'>{label}</span>
        </button>
    );
};

const SourceCodeStyleModal = ({
    visible,
    value,
    onSelect,
    onDismissed,
}: {
    visible: boolean;
    value: ButtonStyle;
    onSelect: (style: ButtonStyle) => void;
    onDismissed: () => void;
}) => {
    const { t } = useTranslation('dashboard/index');

    return (
        <Modal visible={visible} onDismissed={onDismissed} size='sm' closeOnBackground={false}>
            <Title className='text-xl !font-bold mb-2'>{t('source-codes.style-modal.title')}</Title>
            <p className='text-sm text-gray-400 mb-5'>{t('source-codes.style-modal.description')}</p>
            <div className='flex flex-col sm:flex-row gap-3'>
                <StyleOptionPreview
                    label={t('source-codes.style-modal.3d')}
                    style='3d'
                    active={value === '3d'}
                    onSelect={() => onSelect('3d')}
                />
                <StyleOptionPreview
                    label={t('source-codes.style-modal.normal')}
                    style='normal'
                    active={value === 'normal'}
                    onSelect={() => onSelect('normal')}
                />
            </div>
        </Modal>
    );
};

export default () => {
    const { t } = useTranslation('dashboard/index');
    const uuid = useStoreState((state) => state.user.data!.uuid);
    const [buttonStyle, setButtonStyle] = usePersistedState<ButtonStyle | null>(
        `${uuid}:source_codes_button_style`,
        null
    );
    const [manuallyOpen, setManuallyOpen] = useState(false);

    const { data: sourceCodes } = useSWR<SourceCode[]>('/api/client/source-codes', () => getSourceCodes());

    if (!sourceCodes || sourceCodes.length === 0) {
        return null;
    }

    const effectiveStyle: ButtonStyle = buttonStyle ?? 'normal';
    const modalVisible = buttonStyle === null || manuallyOpen;

    return (
        <div className='mb-8'>
            <SourceCodeStyleModal
                visible={modalVisible}
                value={effectiveStyle}
                onSelect={(style) => {
                    setButtonStyle(style);
                    setManuallyOpen(false);
                }}
                onDismissed={() => {
                    setManuallyOpen(false);
                    if (buttonStyle === null) {
                        setButtonStyle('normal');
                    }
                }}
            />

            <div className='flex items-center justify-between gap-4 mb-4'>
                <div>
                    <Title className='text-2xl !font-bold flex items-center gap-2'>
                        <FaCode className='w-5 h-5' />
                        {t('source-codes.title')}
                    </Title>
                    <p className='text-sm text-gray-200/80 hidden lg:block'>{t('source-codes.subtitle')}</p>
                </div>
                <button
                    type='button'
                    onClick={() => setManuallyOpen(true)}
                    className='flex-shrink-0 flex items-center gap-2 text-xs text-gray-300 hover:text-gray-100 uppercase whitespace-nowrap'
                    title={t('source-codes.change-style')}
                >
                    <FaPalette className='w-4 h-4' />
                    <span className='hidden sm:inline'>{t('source-codes.change-style')}</span>
                </button>
            </div>

            <div className='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4'>
                {sourceCodes.map((sourceCode) => (
                    <SourceCodeCard key={sourceCode.id} sourceCode={sourceCode} style={effectiveStyle} />
                ))}
            </div>
        </div>
    );
};
