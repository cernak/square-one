const put = ( key, value ) => {
	window.localStorage.setItem( key, value );
};

const get = ( key ) => {
	return window.localStorage.getItem( key );
};

const remove = ( key ) => {
	return window.localStorage.removeItem( key );
};

const clear = () => {
	window.localStorage.clear();
};

export { put, get, remove, clear }