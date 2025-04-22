import { API_URL } from '$env/static/private';

export const load = async ({ request, fetch }) => {
	const query = `
   {
    me {
     organization {
      media_collections {
       id
       display_name
       name
      }
     }
    }
   }
  `;

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query })
	}).then((res) => res.json());

	console.log(res.data.me.organization);

	return {
		collections: getCollectionsWithHierarchy(res.data.me.organization.media_collections)
	};
};

const getCollectionsWithHierarchy = (collections) => {
	let collectionsWithHierarchy = [];
	const parentMap = {};

	collections.forEach((c) => {
		if (!c.name.includes('/')) {
			const collectionObj = { ...c, children: [] };
			collectionsWithHierarchy.push(collectionObj);
			parentMap[c.name] = collectionObj;
		}
	});

	collections.forEach((c) => {
		if (c.name.includes('/')) {
			const parts = c.name.split('/');
			const parentName = parts[0];
			const childName = parts[1];

			const parent = parentMap[parentName];

			if (parent) {
				parent.children.push({
					...c,
					name: childName
				});
			} else {
				const newParent = {
					name: parentName,
					children: [
						{
							...c,
							name: childName
						}
					]
				};
				collectionsWithHierarchy.push(newParent);
				parentMap[parentName] = newParent;
			}
		}
	});

	return collectionsWithHierarchy;
};
