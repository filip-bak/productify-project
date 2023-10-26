import { Link } from 'react-router-dom';
import './Logo.scss';

const Logo = () => {
  return (
    <div className="logo">
      <Link className="logo__text" to="/">
        Productify
      </Link>
    </div>
  );
};

export default Logo;
