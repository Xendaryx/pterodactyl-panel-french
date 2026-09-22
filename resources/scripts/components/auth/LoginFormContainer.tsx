import React, { forwardRef } from 'react';
import { Form } from 'formik';
import styled from 'styled-components/macro';
import FlashMessageRender from '@/components/FlashMessageRender';
import tw from 'twin.macro';

type Props = React.DetailedHTMLProps<React.FormHTMLAttributes<HTMLFormElement>, HTMLFormElement> & {
    title?: string;
};

const Page = styled.div`
    ${tw`w-full min-h-screen flex items-center justify-center px-4 py-10`}

    position: relative;
    overflow: hidden;
    background:
        radial-gradient(circle at 20% 20%, rgba(0, 174, 255, 0.14), transparent 35%),
        radial-gradient(circle at 80% 75%, rgba(0, 92, 255, 0.12), transparent 38%),
        linear-gradient(135deg, #020611 0%, #061225 48%, #020713 100%);

    &::before {
        content: '';
        position: absolute;
        width: 520px;
        height: 520px;
        top: -260px;
        right: -180px;
        border-radius: 9999px;
        background: rgba(0, 183, 255, 0.08);
        filter: blur(80px);
        pointer-events: none;
    }

    &::after {
        content: '';
        position: absolute;
        width: 420px;
        height: 420px;
        bottom: -240px;
        left: -150px;
        border-radius: 9999px;
        background: rgba(0, 102, 255, 0.09);
        filter: blur(80px);
        pointer-events: none;
    }
`;

const Container = styled.div`
    ${tw`w-full relative`}
    max-width: 1000px;
    z-index: 1;
`;

const LoginGrid = styled.div`
    display: grid;
    grid-template-columns: 1fr;
    gap: 28px;
    align-items: center;

    @media (min-width: 768px) {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }
`;

const BrandSide = styled.div`
    display: flex;
    align-items: center;
    justify-content: center;
`;

const FormSide = styled.div`
    width: 100%;
    max-width: 480px;
    justify-self: center;

    @media (min-width: 768px) {
        justify-self: end;
    }
`;


const Logo = styled.img`
    display: block;
    width: 245px;
    max-width: 80%;
    height: auto;
    margin: 0 auto 18px;
    filter: drop-shadow(0 0 24px rgba(0, 183, 255, 0.28));
`;

const Title = styled.h2`
    ${tw`text-center font-medium`}
    margin: 0 0 24px;
    color: #f4fbff;
    font-size: 1.55rem;
    letter-spacing: 0.025em;
    text-shadow: 0 0 22px rgba(0, 183, 255, 0.18);
`;

const Card = styled.div`
    padding: 32px;

    @media (min-width: 768px) {
        padding: 40px;
    }
    border: 1px solid rgba(68, 195, 255, 0.22);
    border-radius: 18px;
    background: linear-gradient(
        145deg,
        rgba(11, 25, 48, 0.88),
        rgba(4, 12, 27, 0.82)
    );
    box-shadow:
        0 28px 70px rgba(0, 0, 0, 0.48),
        inset 0 1px 0 rgba(255, 255, 255, 0.04),
        0 0 40px rgba(0, 140, 255, 0.07);
    /* backdrop-filter retiré : corrige le positionnement reCAPTCHA */
`;

const Footer = styled.p`
    ${tw`text-center text-xs`}
    margin-top: 20px;
    color: rgba(160, 190, 215, 0.62);
    letter-spacing: 0.035em;

    a {
        color: rgba(96, 202, 255, 0.78);
        text-decoration: none;
        transition: color 150ms ease;
    }

    a:hover {
        color: #8bdcff;
    }
`;

export default forwardRef<HTMLFormElement, Props>(({ title, ...props }, ref) => (
    <Page>
        <Container>
            <LoginGrid>
                <BrandSide>
                    <Logo src={'/assets/xaryon-studio-logo.png'} alt={'Xaryon Studio'} />
                </BrandSide>

                <FormSide>
                    <FlashMessageRender css={tw`mb-3 px-1`} />
                    <Form {...props} ref={ref}>
                        <Card>
                            {title && <Title>{title}</Title>}
                            {props.children}
                        </Card>
                    </Form>
                </FormSide>
            </LoginGrid>

            <Footer>
                &copy; {new Date().getFullYear()} Xaryon Studio
                {' — '}
                Gestionnaire de serveurs
                {' · '}
                Propulsé par{' '}
                Pterodactyl
            </Footer>
        </Container>
    </Page>
));
