import { useLocation } from 'react-router-dom';
import './Header.scss';
import headersRoute from './headerRoute';

const Header = () => {
  const location = useLocation();

  const header = headersRoute.find(
    (header) => location.pathname === header.path
  );

  if (!header) return;

  return (
    <header className="header">
      <h1 className="header__title">{header.title}</h1>
    </header>
  );
};

export default Header;
